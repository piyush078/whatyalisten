import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Params } from '@angular/router';

import { ApiService } from '../api.service';
import { ErrorService } from '../error.service';

@Component ({
  selector: 'artist',
  templateUrl: './artist.component.html',
  styleUrls: ['./artist.component.css']
})

export class ArtistComponent implements OnInit {

  /**
   * Variable to store the results.
   * Variables for parameters for request.
   *
   * @var mixed
   */
  private results: Object;
  private url: string = 'artist';
  private albumsUrl: string = '/albums';

  constructor (
    private api: ApiService,
    private error: ErrorService,
    private route: ActivatedRoute
  ) {}

  ngOnInit () {
    this.route.params.forEach (
      (params: Params) => {
        this.results = null;
        this.getArtist ()
      }
    );
  }

  /**
   * Send request to fetch data about artist id.
   *
   * @param  void
   * @return void
   */
  getArtist (): void {
    const id = this.route.snapshot.paramMap.get ('id');
    this.api.fetchData (this.url, { 'id': id }).subscribe (
      data => {
        const artist = data;
        this.api.fetchData (this.url + this.albumsUrl, { 'id': id }).subscribe (
          data => this.results = Object.assign (artist, data),
          error => this.results = artist
        )
      },
      error => this.error.formatError (error)
    );
  }
}
