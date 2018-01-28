import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Params } from '@angular/router';

import { ApiService } from '../api.service';
import { ErrorService } from '../error.service';

@Component ({
  selector: 'track',
  templateUrl: './track.component.html',
  styleUrls: ['./track.component.css']
})

export class TrackComponent implements OnInit {

  /**
   * Variable to store the results.
   * Variables for parameters for request.
   *
   * @var mixed
   */
  private results: Object;
  private url: string = 'track';

  constructor (
    private api: ApiService,
    private error: ErrorService,
    private route: ActivatedRoute
  ) {}

  ngOnInit () {
    this.route.params.forEach (
      (params: Params) => {
        this.results = null;
        this.getTrack ()
      }
    );
  }

  /**
   * Send request to fetch data about track id.
   *
   * @param  void
   * @return void
   */
  getTrack (): void {
  	const id = this.route.snapshot.paramMap.get ('id');
    this.api.fetchData (this.url, { 'id': id }).subscribe (
      data => this.results = data,
      error => this.error.formatError (error)
    );
  }
}
